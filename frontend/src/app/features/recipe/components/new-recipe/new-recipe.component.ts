import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { catchError, EMPTY, forkJoin, Observable } from 'rxjs';
import { Ingredient, IngredientCategory } from 'src/app/shared/models/ingredient.model';
import { NewRecipe, NewRecipeCategory, NewRecipeIngredient, RecipeCategory } from 'src/app/shared/models/recipe.model';
import { IngredientService } from 'src/app/shared/services/ingredient.service';
import { RecipeService } from 'src/app/shared/services/recipe.service';
import { CategoryService } from '../../services/category.service';
import { ImageService } from '../../services/image.service';
import { RecipesComponent } from '../recipes/recipes.component';

@Component({
  selector: 'app-new-recipe',
  templateUrl: './new-recipe.component.html',
  styleUrls: ['./new-recipe.component.scss']
})
export class NewRecipeComponent {
  recipeForm!: FormGroup;

  categories!: RecipeCategory[];

  ingredients!: Ingredient[];

  ingredientCategories!: IngredientCategory[];

  imageHashName!: string;

  recipe!: NewRecipe;

  constructor(
    private fb: FormBuilder,
    private recipeService: RecipeService,
    private categoryService: CategoryService,
    private ingredientService: IngredientService,
    private imageService: ImageService,
    private recipesComponent: RecipesComponent) {

    this.categoryService.getCategories()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.categories = data.data;
        }
      });

    this.ingredientService.getIngredientCategories()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.ingredientCategories = data.data;
        }
      });

    this.ingredientService.getIngredients()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.ingredients = data.data;
        }
      });

    this.recipeForm = this.fb.group({
      name: ['', Validators.required],
      time: ['', Validators.required],
      portions: ['', Validators.required],
      instructions: ['', Validators.required],
      favorite: [false],
      image: [null, Validators.required],
      categorySelector: [null, Validators.required],
      ingredientsArray: this.fb.array([]),
      newIngredientsArray: this.fb.array([])
    });
  }

  get name() { return this.recipeForm.get('name'); }
  get time() { return this.recipeForm.get('time'); }
  get portions() { return this.recipeForm.get('portions'); }
  get instructions() { return this.recipeForm.get('instructions'); }
  get favorite() { return this.recipeForm.get('favorite'); }
  get image() { return this.recipeForm.get('image'); }
  get categorySelector() { return this.recipeForm.get('categorySelector'); }
  get ingredientsArray() { return <FormArray>this.recipeForm.get('ingredientsArray'); }
  get newIngredientsArray() { return <FormArray>this.recipeForm.get('newIngredientsArray'); }

  createSelectIngredientForm(): FormGroup {
    return this.fb.group({
      ingredientSelector: [null, Validators.required],
      gramsSelect: [0, Validators.required]
    });
  }

  createAddIngredientForm(): FormGroup {
    return this.fb.group({
      ingredientName: ['', Validators.required],
      ingredientCategory: [null, Validators.required],
      gramsCreate: [0, Validators.required]
    });
  }

  addSelectIngredientForm() {
    this.ingredientsArray.push(this.createSelectIngredientForm());
  }

  removeSelectIngredientForm(index: number) {
    this.ingredientsArray.removeAt(index);
  }

  addCreateIngredientForm() {
    this.newIngredientsArray.push(this.createAddIngredientForm());
  }

  removeCreateIngredientForm(index: number) {
    this.newIngredientsArray.removeAt(index);
  }

  uploadImage(event: Event) {
    const file = (event.target as HTMLInputElement)?.files?.[0];
    this.recipeForm.patchValue({
      image: file
    });

    const formData: any = new FormData();
    formData.append("image", this.image?.value);

    this.imageService.uploadImage(formData)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.imageHashName = data.data;
        }
      });
  }

  createRecipe() {

    var tasksToBackend = [];
    var newIngredientsCount = 0;

    var recipeIngredients: NewRecipeIngredient[] = [];

    for (var newIngredient of this.newIngredientsArray.controls) {

      var ingredientId: number = 0;

      var ingredient = {
        name: newIngredient.get('ingredientName')?.value,
        ingredient_category_id: newIngredient.get('ingredientCategory')?.value,
        pantry: false,
        shoplist: false
      }

      tasksToBackend.push(this.ingredientService.createIngredient(ingredient));
      newIngredientsCount = newIngredientsCount + 1;
    }

    for (var newIngredient of this.ingredientsArray.controls) {
      var selectedIngredient = {
        id: newIngredient.get('ingredientSelector')?.value,
        grams: newIngredient.get('gramsSelect')?.value
      }
      recipeIngredients.push(selectedIngredient);

    }

    var selectedCategories: NewRecipeCategory[] = [];

    for (var category of this.categorySelector?.value) {
      selectedCategories.push({
        id: category
      });
    }

    this.recipe = {
      'name': this.name?.value,
      'time': this.time?.value,
      'portions': this.portions?.value,
      'instructions': this.instructions?.value,
      'favorite': this.favorite?.value ? false : true,
      'image': this.imageHashName,
      'categories': selectedCategories,
      'ingredients': recipeIngredients
    }

    tasksToBackend.push(this.recipeService.createRecipe(this.recipeObject));

    forkJoin([...tasksToBackend])
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          for (let index = 0; index < newIngredientsCount; index++) {
            const ingredientId = data[index].data.id;

            if (ingredientId > 0) {
              this.recipe.ingredients.push({
                id: ingredientId,
                grams: 10//newIngredient.get('gramsCreate')?.value,//TODO como accedo a esto??
              });
            }
          }
        }
      });

    this.recipesComponent.reloadRecipes();
  }

  cancel() {
    this.recipeForm.reset();
    this.ingredientsArray.clear();
    this.newIngredientsArray.clear();
  }

  private handleError(error: HttpErrorResponse) {

    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {
      console.warn('Backend returned code: ', error.status, error.error);
    }

    return EMPTY;
  }

  get recipeObject() { return this.recipe; }

}

import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { catchError, EMPTY } from 'rxjs'; import { Ingredient, IngredientCategory } from 'src/app/shared/models/ingredient.model';
import { RecipeCategory } from 'src/app/shared/models/recipe.model';
import { RecipeService } from 'src/app/shared/services/recipe.service';
import { CategoryService } from '../../services/category.service';

@Component({
  selector: 'app-new-recipe',
  templateUrl: './new-recipe.component.html',
  styleUrls: ['./new-recipe.component.scss']
})
export class NewRecipeComponent {
  recipeForm!: FormGroup;
  categories!: RecipeCategory[];
  selectedCategories!: RecipeCategory[];
  ingredients!: Ingredient[];
  ingredientCategories!: IngredientCategory[];

  constructor(
    private fb: FormBuilder,
    private recipeService: RecipeService,
    private categoryService: CategoryService) {

    this.categoryService.getCategories()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.categories = data.data;
        }
      });

    this.recipeForm = this.fb.group({
      name: ['', Validators.required],
      time: ['', Validators.required],
      portions: ['', Validators.required],
      instructions: ['', Validators.required],
      favorite: [false],
      url: [''],
      image: [null],
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
  get url() { return this.recipeForm.get('url'); }
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

  createRecipe() {

    /*for (var ingredient of this.ingredientsArray.controls){
      this.ingredients.push({

      })
    }*/

    var recipe = {
      'name': this.name?.value,
      'time': this.time?.value,
      'portions': this.portions?.value,
      'instructions': this.instructions?.value,
      'favorite': this.favorite?.value,
      'url': this.url?.value,
      'image': this.image?.value,
      'categories': this.selectedCategories,
      //'ingredients': 
    }

    /*this.recipeService.createRecipe(recipe)
      .pipe(catchError(this.handleError))
      .subscribe();*/
  }

  private handleError(error: HttpErrorResponse) {

    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {
      console.warn('Backend returned code: ', error.status, error.error);
    }

    return EMPTY;
  }

}

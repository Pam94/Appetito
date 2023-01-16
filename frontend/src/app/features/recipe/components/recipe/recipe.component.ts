import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { catchError, EMPTY } from 'rxjs';
import { Constants } from 'src/app/shared/constants';
import { Recipe, RecipeCategory, RecipeIngredient } from 'src/app/shared/models/recipe.model';
import { RecipeService } from 'src/app/shared/services/recipe.service';

@Component({
  selector: 'app-recipe',
  templateUrl: './recipe.component.html',
  styleUrls: ['./recipe.component.scss']
})
export class RecipeComponent {
  recipe!: Recipe;
  ingredients!: RecipeIngredient[];
  categories!: RecipeCategory[];
  imagePath: string = this.constants.API_IMAGES_STORAGE;

  constructor(
    private recipeService: RecipeService,
    private constants: Constants,
    private activatedRoute: ActivatedRoute,
    private router: Router) {

    const identifier = this.activatedRoute.snapshot.paramMap.get('id');

    if (identifier) {

      this.recipeService.getRecipe(identifier)
        .pipe(catchError(this.handleError))
        .subscribe({
          next: (data) => {

            if (!data.data) {
              this.router.navigateByUrl('/recipes');
            }

            this.recipe = data.data;

            this.categories = this.recipe.categories;
            this.ingredients = this.recipe.ingredients;
          }
        });
    }

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

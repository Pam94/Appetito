import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { catchError, EMPTY } from 'rxjs';
import { Constants } from 'src/app/shared/constants';
import { Recipe, RecipeCategory } from 'src/app/shared/models/recipe.model';
import { RecipeService } from 'src/app/shared/services/recipe.service';

@Component({
  selector: 'app-recipes',
  templateUrl: './recipes.component.html',
  styleUrls: ['./recipes.component.scss']
})
export class RecipesComponent {
  recipes!: Recipe[];
  imagePath: string = this.constants.API_THUMBNAILS_STORAGE;
  categories!: RecipeCategory[];

  constructor(
    private constants: Constants,
    private recipeService: RecipeService) {

    this.recipeService.getRecipes()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data;
        }
      });
  }

  deleteRecipe(recipe: Recipe) {
    this.recipeService.deleteRecipe(recipe.id)
      .pipe(catchError(this.handleError))
      .subscribe();

    this.recipeService.getRecipes()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data;
        }
      });
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

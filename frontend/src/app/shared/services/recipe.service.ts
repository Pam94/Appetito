import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from '../constants';
import { NewRecipe } from '../models/recipe.model';

@Injectable({
  providedIn: 'root'
})
export class RecipeService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants
  ) { }

  getRecipes(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_RECIPES);
  }

  getRecipe(recipeId: string): Observable<any> {
    return this.apiHttpService.get(this.constants.API_RECIPES + '/' + recipeId);
  }

  deleteRecipe(recipeId: number): Observable<any> {
    return this.apiHttpService.delete(this.constants.API_RECIPES + '/' + recipeId);
  }

  createRecipe(recipe: NewRecipe): Observable<any> {
    return this.apiHttpService.post(this.constants.API_RECIPES, recipe);
  }
}

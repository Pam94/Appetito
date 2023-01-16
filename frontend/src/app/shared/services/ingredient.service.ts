import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from '../constants';
import { Ingredient, NewIngredient } from '../models/ingredient.model';

@Injectable({
  providedIn: 'root'
})
export class IngredientService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  getIngredients(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_INGREDIENTS);
  }

  getIngredientsInShoplist(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_INGREDIENTS_SHOPLIST);
  }

  getIngredientCategories(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_INGREDIENT_CATEGORIES);
  }

  createIngredient(newIngredient: NewIngredient): Observable<any> {
    return this.apiHttpService.post(this.constants.API_INGREDIENTS, newIngredient);
  }

  removeFromShoplist(ingredient: Ingredient): Observable<any> {
    return this.apiHttpService.put(this.constants.API_INGREDIENTS + ingredient.id, ingredient);
  }

  markIngredientInPantry(ingredient: Ingredient): Observable<any> {
    return this.apiHttpService.put(this.constants.API_INGREDIENTS + ingredient.id, ingredient);
  }
}

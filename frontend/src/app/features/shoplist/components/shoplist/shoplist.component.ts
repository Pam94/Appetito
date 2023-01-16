import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { catchError, EMPTY } from 'rxjs';
import { Category } from 'src/app/features/recipe/models/category.model';
import { Constants } from 'src/app/shared/constants';
import { Ingredient } from 'src/app/shared/models/ingredient.model';
import { IngredientService } from 'src/app/shared/services/ingredient.service';

@Component({
  selector: 'app-shoplist',
  templateUrl: './shoplist.component.html',
  styleUrls: ['./shoplist.component.scss']
})
export class ShoplistComponent {
  ingredients!: Ingredient[];
  categories!: Category[];

  constructor(
    private ingredientService: IngredientService
  ) {

    this.reloadIngredients();
  }

  reloadIngredients() {
    this.ingredientService.getIngredientsInShoplist()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.ingredients = data.data;
        }
      });
  }

  check(ingredient: Ingredient) {
    this.ingredientService.markIngredientInPantry(ingredient);
  }

  removefromList(ingredient: Ingredient) {
    this.ingredientService.removeFromShoplist(ingredient);
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

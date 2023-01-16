import { Component } from '@angular/core';
import { Constants } from 'src/app/shared/constants';
import { Recipe, RecipeIngredient } from 'src/app/shared/models/recipe.model';
import { RecipeService } from 'src/app/shared/services/recipe.service';
import { Category } from '../../models/category.model';

@Component({
  selector: 'app-recipe',
  templateUrl: './recipe.component.html',
  styleUrls: ['./recipe.component.scss']
})
export class RecipeComponent {
  recipe!: Recipe;
  ingredients!: RecipeIngredient[];
  categories!: Category[];
  imagePath: string = this.constants.API_IMAGES_STORAGE;

  constructor(
    private recipeService: RecipeService,
    private constants: Constants) {

  }
}

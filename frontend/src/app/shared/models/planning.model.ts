import { Recipe } from "./recipe.model";

export interface Planning {
  date: string;
  recipes: Recipe[];
}

export interface UpdatePlanning {
  date: string;
  recipe_id: number;
  recipe_meal: string;
}
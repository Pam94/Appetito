import { Recipe } from "./recipe.model";

export interface Planning {
  date: string,
  recipes: Recipe[]
}
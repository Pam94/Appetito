import { PlanningRecipe } from "./recipe.model";

export interface Planning {
  date: string;
  recipes: PlanningRecipe[];
}

export interface UpdatePlanning {
  date: string;
  recipe_id: number;
  recipe_meal: string;
}
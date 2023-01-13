export interface newRecipe {
  name: string;
  time: number;
  portions: number;
  instructions: string;
  favorite: boolean;
  url: string;
  image_name: string;
}

export interface Pivot {
  planning_id: number;
  recipe_id: number;
  meal: string;
}

export interface Recipe {
  id: number;
  name: string;
  time: number;
  portions: number;
  instructions: string;
  favorite: boolean;
  url: string;
  image_name: string;
  pivot: Pivot;
  user_id: number;
  updated_at: Date;
  created_at: Date;
}
export interface PlanningRecipePivot {
  planning_id: number;
  recipe_id: number;
  meal: string;
}

export interface PlanningRecipe {
  id: number;
  name: string;
  time: number;
  portions: number;
  instructions: string;
  favorite: boolean;
  url: string;
  image: string;
  pivot: PlanningRecipePivot;
  user_id: number;
  updated_at: Date;
  created_at: Date;
}

export interface RecipeIngredientPivot {
  recipe_id: number;
  ingredient_id: number;
  grams: number;
}

export interface RecipeIngredient {
  id: number;
  name: string;
  pantry: boolean;
  shoplist: boolean;
  user_id: number;
  ingredient_category_id: number;
  updated_at: Date;
  created_at: Date;
  pivot: RecipeIngredientPivot;
}

export interface RecipeCategoryPivot {
  recipe_id: number;
  category_id: number;
}

export interface RecipeCategory {
  id: number;
  name: string;
  icon_name: string;
  updated_at: Date;
  created_at: Date;
  pivot: RecipeCategoryPivot;
}

export interface Recipe {
  id: number;
  name: string;
  time: number;
  portions: number;
  instructions: string;
  favorite: boolean;
  url: string;
  image: string;
  ingredients: RecipeIngredient[],
  categories: RecipeCategory[],
}

export interface NewRecipeIngredient {
  id: number;
  grams: number;
}

export interface NewRecipeCategory {
  id: number;
}

export interface NewRecipe {
  name: string;
  time: number;
  portions: number;
  instructions: string;
  favorite: boolean;
  image: string;
  categories: NewRecipeCategory[],
  ingredients: NewRecipeIngredient[]
}
export interface CategoryRecipe {
    id: number;
    name: string;
    time: number;
    portions: number;
    instructions: string;
    favorite: boolean;
    url: string;
    image_name: string;
}


export interface Category {
    id: number;
    name: string;
    icon_name: string;
    recipes: CategoryRecipe[];
}
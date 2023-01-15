export interface IngredientCategory {
    id: number;
    name: string;
    icon_name: string;

}

export interface Ingredient {
    id: number;
    name: string;
    pantry: boolean;
    shoplist: boolean;
}
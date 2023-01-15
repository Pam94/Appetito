export class Constants {
    public readonly API_ENDPOINT: string = 'http://127.0.0.1:8000/api/';

    public readonly API_ENDPOINT_VERSION: string = 'http://127.0.0.1:8000/api/v1/';

    public readonly API_REGISTER: string = this.API_ENDPOINT + 'register';
    public readonly API_LOGIN: string = this.API_ENDPOINT + 'login';

    public readonly API_IMAGES_STORAGE: string = this.API_ENDPOINT + 'images/';
    public readonly API_THUMBNAILS_STORAGE: string = this.API_ENDPOINT + 'thumbnails/';

    public readonly API_PLANNING: string = this.API_ENDPOINT_VERSION + 'plannings';

    public readonly API_RECIPES: string = this.API_ENDPOINT_VERSION + 'recipes';

    public readonly API_RECIPE_CATEGORIES: string = this.API_ENDPOINT_VERSION + 'categories';

    public readonly API_RECIPE_INGREDIENTS: string = this.API_ENDPOINT_VERSION + 'ingredients';
}
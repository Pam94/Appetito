import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from '../constants';

@Injectable({
  providedIn: 'root'
})
export class RecipeService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants
  ) { }

  getRecipes(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_RECIPES);
  }
}

import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from '../constants';

@Injectable({
  providedIn: 'root'
})
export class IngredientService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  getIngredients(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_RECIPE_INGREDIENTS);
  }
}

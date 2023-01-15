import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from 'src/app/shared/constants';

@Injectable({
  providedIn: 'root'
})
export class CategoryService {

  constructor(private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  getCategories(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_RECIPE_CATEGORIES);
  }
}

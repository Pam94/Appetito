import { HttpHeaders } from '@angular/common/http';
import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from 'src/app/shared/constants';

@Injectable({
  providedIn: 'root'
})
export class PlanningService {

  httpOptions = {
    headers: new HttpHeaders(
      { 'Content-Type': 'application/json' })
  };

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants
  ) { }

  getPlanningByDate($date: string): Observable<any> {
    return this.apiHttpService.get(this.constants.API_PLANNING + '/' + $date);
  }
}

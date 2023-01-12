import { DatePipe, formatDate } from '@angular/common';
import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { catchError, throwError } from 'rxjs';
import { Recipe } from 'src/app/shared/models/recipe.model';
import { PlanningService } from '../../services/planning.service';

@Component({
  selector: 'app-planning',
  templateUrl: './planning.component.html',
  styleUrls: ['./planning.component.scss'],
  providers: [DatePipe]
})
export class PlanningComponent {
  recipes!: any[];
  date!: Date;
  dateString: string;

  constructor(private planningService: PlanningService) {

    this.date = new Date();
    var today = formatDate(this.date, 'yyyy-MM-dd', 'en');

    this.dateString = today;
    this.planningService.getPlanningByDate(today)
      .pipe(catchError(this.handleError))
      .subscribe((data) => {

        this.recipes = data.data.recipes;
      });
  }

  nextDay() {

    this.date.setDate(this.date.getDate() + 1);

    var nextDay = formatDate(this.date, 'yyyy-MM-dd', 'en');

    this.planningService.getPlanningByDate(nextDay)
      .pipe(catchError(this.handleError))
      .subscribe((data) => {
        this.recipes = data.data.recipes;
      });
  }

  previous() {

    this.date.setDate(this.date.getDate() - 1);

    var nextDay = formatDate(this.date, 'yyyy-MM-dd', 'en');

    this.planningService.getPlanningByDate(nextDay)
      .pipe(catchError(this.handleError))
      .subscribe((data) => {
        this.recipes = data.data.recipes;
      });
  }

  private handleError(error: HttpErrorResponse) {
    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {
      console.error('Backend returned code: ', error.status, error.error);
    }

    return throwError(() => new Error('ERROR'));
  }
}

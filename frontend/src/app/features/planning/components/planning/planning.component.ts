import { formatDate } from '@angular/common';
import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { catchError, EMPTY } from 'rxjs';
import { Constants } from 'src/app/shared/constants';
import { PlanningRecipe } from 'src/app/shared/models/recipe.model';
import { PlanningService } from '../../services/planning.service';

@Component({
  selector: 'app-planning',
  templateUrl: './planning.component.html',
  styleUrls: ['./planning.component.scss']
})
export class PlanningComponent {
  recipes!: PlanningRecipe[];
  date!: Date;
  dateString: string;
  imagePath: string = this.constants.API_THUMBNAILS_STORAGE;

  constructor(
    private constants: Constants,
    private planningService: PlanningService) {

    this.date = new Date();
    var today = formatDate(this.date, 'yyyy-MM-dd', 'en');

    this.dateString = today;
    this.planningService.getPlanningByDate(today)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data.recipes;
        }
      });
  }

  nextDay() {

    this.date.setDate(this.date.getDate() + 1);

    var nextDay = formatDate(this.date, 'yyyy-MM-dd', 'en');
    this.dateString = nextDay;

    this.recipes = [];

    this.planningService.getPlanningByDate(nextDay)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data.recipes;
        }
      });
  }

  previousDay() {

    this.date.setDate(this.date.getDate() - 1);

    var previousDay = formatDate(this.date, 'yyyy-MM-dd', 'en');
    this.dateString = previousDay;

    this.recipes = [];

    this.planningService.getPlanningByDate(previousDay)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data.recipes;
        }
      });
  }

  deleteRecipeFromPlan(recipe: PlanningRecipe) {
    var planningDate = formatDate(this.date, 'yyyy-MM-dd', 'en');
    var planning = {
      'date': planningDate,
      'recipe_id': recipe.id,
      'recipe_meal': recipe.pivot.meal
    };
    this.planningService.updatePlanning(planning)
      .pipe(catchError(this.handleError))
      .subscribe();

    this.planningService.getPlanningByDate(planningDate)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data.recipes;
        }
      });
  }

  private handleError(error: HttpErrorResponse) {
    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {
      console.warn('Backend returned code: ', error.status, error.error);
    }

    return EMPTY;
  }
}

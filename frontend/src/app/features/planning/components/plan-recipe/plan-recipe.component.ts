
import { formatDate } from '@angular/common';
import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormArray, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { catchError, EMPTY, throwError } from 'rxjs';
import { Recipe } from 'src/app/shared/models/recipe.model';
import { RecipeService } from 'src/app/shared/services/recipe.service';
import { PlanningService } from '../../services/planning.service';

@Component({
  selector: 'app-plan-recipe',
  templateUrl: './plan-recipe.component.html',
  styleUrls: ['./plan-recipe.component.scss']
})
export class PlanRecipeComponent {
  planningForm: FormGroup;
  recipes!: Recipe[];
  selectedRecipe!: Recipe;

  constructor(
    private fb: FormBuilder,
    private recipeService: RecipeService,
    private planningService: PlanningService) {

    this.recipeService.getRecipes()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {
          this.recipes = data.data;
        }
      });

    this.planningForm = this.fb.group({
      date: ['', Validators.required],
      mealSelector: [null, Validators.required],
      recipeSelector: [null, Validators.required]
    });

  }

  get date() { return this.planningForm.get('date'); }
  get meal() { return this.planningForm.get('mealSelector'); }
  get recipe() { return this.planningForm.get('recipeSelector'); }

  planRecipe() {
    var selectedRecipe = this.recipe?.value;
    var planning = {
      'date': this.date?.value,
      'recipe_id': selectedRecipe,
      'recipe_meal': this.meal?.value
    }

    this.planningService.createPlanOrUpdate(planning)
      .pipe(catchError(this.handleError))
      .subscribe();
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

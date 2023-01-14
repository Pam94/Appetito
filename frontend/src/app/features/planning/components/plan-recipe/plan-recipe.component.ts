import { Component } from '@angular/core';
import { FormGroup } from '@angular/forms';

@Component({
  selector: 'app-plan-recipe',
  templateUrl: './plan-recipe.component.html',
  styleUrls: ['./plan-recipe.component.scss']
})
export class PlanRecipeComponent {
  planningForm!: FormGroup;

  planRecipe() { }

}

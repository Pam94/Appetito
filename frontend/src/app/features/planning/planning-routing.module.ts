import { NgModule } from '@angular/core';
import { RouterModule, Routes } from '@angular/router';
import { PlanRecipeComponent } from './components/plan-recipe/plan-recipe.component';
import { PlanningComponent } from './components/planning/planning.component';

const routes: Routes = [
  { path: 'planning', component: PlanningComponent },
  { path: 'planRecipe', component: PlanRecipeComponent },
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class PlanningRoutingModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PlanningRoutingModule } from './planning-routing.module';

import { PlanningComponent } from './components/planning/planning.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { PlanRecipeComponent } from './components/plan-recipe/plan-recipe.component';


@NgModule({
  declarations: [
    PlanningComponent,
    PlanRecipeComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    PlanningRoutingModule
  ]
})
export class PlanningModule { }

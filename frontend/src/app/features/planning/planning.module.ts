import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PlanningRoutingModule } from './planning-routing.module';

import { PlanningComponent } from './components/planning/planning.component';
import { SharedModule } from 'src/app/shared/shared.module';
import { PlanRecipeComponent } from './components/plan-recipe/plan-recipe.component';
import { ReactiveFormsModule } from '@angular/forms';


@NgModule({
  declarations: [
    PlanningComponent,
    PlanRecipeComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    ReactiveFormsModule,

    PlanningRoutingModule
  ]
})
export class PlanningModule { }

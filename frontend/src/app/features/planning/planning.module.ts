import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PlanningRoutingModule } from './planning-routing.module';

import { PlanningComponent } from './components/planning/planning.component';
import { SharedModule } from 'src/app/shared/shared.module';


@NgModule({
  declarations: [
    PlanningComponent
  ],
  imports: [
    CommonModule,
    SharedModule,
    PlanningRoutingModule
  ]
})
export class PlanningModule { }

import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { PlanningRoutingModule } from './planning-routing.module';

import { CalendarComponent } from './components/calendar/calendar.component';
import { PlanningComponent } from './components/planning/planning.component';


@NgModule({
  declarations: [
    CalendarComponent,
    PlanningComponent
  ],
  imports: [
    CommonModule,
    PlanningRoutingModule
  ]
})
export class PlanningModule { }

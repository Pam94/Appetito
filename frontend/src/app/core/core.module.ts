import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { RegisterComponent } from './components/register/register.component';
import { LoginComponent } from './components/login/login.component';
import { ProfileComponent } from './components/profile/profile.component';

import { HttpClientModule } from '@angular/common/http';
import { ReactiveFormsModule } from '@angular/forms';
import { ApiHttpService } from './services/api-http.service';
import { CoreRoutingModule } from './core-routing.module';

import { MdbFormsModule } from 'mdb-angular-ui-kit/forms';
import { SharedModule } from '../shared/shared.module';

@NgModule({
  providers: [
    ApiHttpService
  ],
  declarations: [
    RegisterComponent,
    LoginComponent,
    ProfileComponent
  ],
  imports: [
    CommonModule,
    HttpClientModule,
    ReactiveFormsModule,


    SharedModule,
    MdbFormsModule,

    CoreRoutingModule
  ]
})
export class CoreModule { }

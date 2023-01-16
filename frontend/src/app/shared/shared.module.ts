import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { TokenService } from './services/token.service';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { AuthInterceptor } from './interceptors/auth.interceptor';
import { Constants } from './constants';
import { SharedRoutingModule } from './shared-routing.module';
import { MainNavComponent } from './components/main-nav/main-nav.component';

@NgModule({
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    },
    Constants,
    TokenService
  ],
  declarations: [
    MainNavComponent
  ],
  imports: [
    CommonModule,
    SharedRoutingModule
  ],
  exports: [
    MainNavComponent
  ]
})
export class SharedModule { }

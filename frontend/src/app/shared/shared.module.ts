import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';

import { HeaderNavComponent } from './components/header-nav/header-nav.component';
import { TokenService } from './services/token.service';
import { HTTP_INTERCEPTORS } from '@angular/common/http';
import { AuthInterceptor } from './interceptors/auth.interceptor';



@NgModule({
  providers: [
    {
      provide: HTTP_INTERCEPTORS,
      useClass: AuthInterceptor,
      multi: true
    }
  ],
  declarations: [
    HeaderNavComponent,
    TokenService
  ],
  imports: [
    CommonModule
  ]
})
export class SharedModule { }

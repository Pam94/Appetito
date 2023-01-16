import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';
import { TokenService } from 'src/app/shared/services/token.service';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.scss']
})
export class LoginComponent {
  loginForm: FormGroup;
  errors!: any[];

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private tokenService: TokenService) {

    this.loginForm = this.fb.group({
      email: ['', [Validators.required, Validators.email]],
      password: ['', Validators.required]
    });
  }

  login() {
    this.authService.login(this.loginForm.value)
      .pipe(catchError(this.handleError))
      .subscribe((data) => {

        this.tokenService.setToken(data.token);
        this.loginForm.reset();
        this.router.navigate(['planning']);
      });
  }

  get email() { return this.loginForm.get('email'); }
  get password() { return this.loginForm.get('password'); }

  private handleError(error: HttpErrorResponse) {
    var errorMessages = [];

    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {

      console.error('Backend returned code: ', error.status, error.error);
      errorMessages.push(error.error.message);
      this.errors = errorMessages;
    }

    return throwError(() => new Error('ERROR'));
  }

}

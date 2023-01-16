import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { Router } from '@angular/router';
import { catchError, throwError } from 'rxjs';
import { passwordValidator } from 'src/app/core/directives/password-validator.directive';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent {
  registerForm: FormGroup;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router) {

    this.registerForm = this.fb.group({
      name: ['', Validators.required],
      surname: ['', Validators.required],
      email: ['', [Validators.required, Validators.email]],
      password: ['', [Validators.required, Validators.minLength(8)]],
      repeatPassword: ['', [Validators.required, Validators.minLength(8)]]
    }, { validators: passwordValidator });
  }

  register() {
    this.authService.register(this.registerForm.value)
      .pipe(catchError(this.handleError))
      .subscribe(() => {
        this.registerForm.reset();
        this.router.navigate(['']);
      });
  }

  get name() { return this.registerForm.get('name'); }
  get surname() { return this.registerForm.get('surname'); }
  get email() { return this.registerForm.get('email'); }
  get password() { return this.registerForm.get('password'); }
  get repeatPassword() { return this.registerForm.get('repeatPassword'); }

  private handleError(error: HttpErrorResponse) {
    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {

      console.error('Backend returned code ${error.status}: ', error.error);
    }

    return throwError(() => new Error('ERROR'));
  }

}

import { HttpErrorResponse } from '@angular/common/http';
import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { catchError, EMPTY } from 'rxjs';
import { TokenService } from 'src/app/shared/services/token.service';
import { User } from '../../models/user.model';
import { AuthService } from '../../services/auth.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.scss']
})
export class ProfileComponent {
  user!: User;

  constructor(
    private authService: AuthService,
    private tokenService: TokenService,
    private router: Router
  ) {

    this.authService.profile()
      .pipe(catchError(this.handleError))
      .subscribe({
        next: (data) => {

          if (!data) {
            this.router.navigateByUrl('/');
          }

          this.user = data;
        }
      });

  }

  logout() {
    this.authService.logout(this.user)
      .pipe(catchError(this.handleError))
      .subscribe({
        next: () => {
          this.router.navigateByUrl('/');
        }
      });
    this.tokenService.removeToken();
  }


  private handleError(error: HttpErrorResponse) {
    if (error.status === 0) {
      console.error('Client-side or network error ocurred', error.error);
    } else {
      console.warn('Backend returned code: ', error.status, error.error);
    }

    return EMPTY;
  }
}

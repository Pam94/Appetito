import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { Constants } from 'src/app/shared/constants';
import { User, UserRegister, UserLogin } from '../models/user.model';
import { ApiHttpService } from './api-http.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  register(user: UserRegister): Observable<any> {
    return this.apiHttpService.post(this.constants.API_REGISTER, user);
  }

  login(user: UserLogin): Observable<any> {
    return this.apiHttpService.post(this.constants.API_LOGIN, user);
  }

  profile(): Observable<any> {
    return this.apiHttpService.get(this.constants.API_PROFILE);
  }

  logout(user: User): Observable<any> {
    return this.apiHttpService.post(this.constants.API_LOGOUT, user);
  }
}

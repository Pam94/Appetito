import { Injectable } from '@angular/core';
import { Constants } from '../constants';
import { User } from '../models/user.model';
import { ApiHttpService } from './api-http.service';

@Injectable({
  providedIn: 'root'
})
export class AuthService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  register(user: User) {
    return this.apiHttpService.post(this.constants.API_REGISTER, user);
  }

  login(user: User) {
    return this.apiHttpService.post(this.constants.API_LOGIN, user);
  }
}

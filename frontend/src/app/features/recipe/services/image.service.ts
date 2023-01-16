import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { ApiHttpService } from 'src/app/core/services/api-http.service';
import { Constants } from 'src/app/shared/constants';

@Injectable({
  providedIn: 'root'
})
export class ImageService {

  constructor(
    private apiHttpService: ApiHttpService,
    private constants: Constants) { }

  uploadImage(image: any): Observable<any> {
    return this.apiHttpService.post(this.constants.API_UPLOAD_IMAGE, image);
  }

  updateImage(formData: any): Observable<any> {
    return this.apiHttpService.post(this.constants.API_UPDATE_IMAGE, formData);
  }
}

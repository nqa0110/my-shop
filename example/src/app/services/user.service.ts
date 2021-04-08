import { Injectable } from '@angular/core';
import {
  HttpClient,
  HttpErrorResponse,
  HttpHeaders,
} from '@angular/common/http';
import { environment as env } from 'src/environments/environment';
import { catchError, map } from 'rxjs/operators';
import { Observable } from 'rxjs';
import { throwError } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class UserService {
  url = env.BASE_URL;
  constructor(private http: HttpClient) {
    this.getUser().subscribe();
  }

  login(user): Observable<any> {
    return this.http.post(this.url + 'login', user).pipe(
      map((res: any) => {
        if (res) {
          return res;
        }
      })
    );
  }

  getUser(): Observable<any> {
    return this.http.get<any>(this.url + 'getUser').pipe(
      map((res: any) => {
        if (res) {
          return res;
        }
      }),
      catchError((err) => {
        localStorage.removeItem('token');
        console.log('Handling error locally and rethrowing it...');
        return throwError(err);
      })
    );
  }
  errorHandler(error: HttpErrorResponse) {
    return Observable.throw(error.message || 'server error.');
  }
  isAuthenticated(): boolean {
    if (localStorage.getItem('token')) return true;
    return false;
  }
}

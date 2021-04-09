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
import { Router } from '@angular/router';
import * as $ from "jquery";

@Injectable({
  providedIn: 'root'
})
export class UserService {
  url = env.BASE_URL;
  constructor(private http: HttpClient, private router: Router) {
    this.getUser().subscribe();
  }

  login(user): Observable<any> {
    return this.http.post(this.url + 'admin/login', user).pipe(
      map((res: any) => {
        if (res) {
          return res;
        }
      })
    );
  }

  getUser(): Observable<any> {
    $("body").hide();
    return this.http.get<any>(this.url + 'user-info').pipe(
      map((res: any) => {
        if (res) {
          $("body").show();
          return res;
        }
      }),
      catchError((err) => {
        localStorage.removeItem('token');
        this.router.navigateByUrl('');
        $("body").show();
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

import { Injectable } from '@angular/core';
import { environment as env } from 'src/environments/environment';
import { HttpClient } from '@angular/common/http'; //call API
import { Router } from '@angular/router';
import { catchError, map } from 'rxjs/operators';
import { Observable } from 'rxjs';

@Injectable({
  providedIn: 'root',
})
export class AuthService {
  url = env.BASE_URL;
  constructor(private http: HttpClient, private _router: Router) {}

  registerUser(user) {
    return this.http.post<any>(this.url + 'register', user);
  }

  loginUser(user) {
    return this.http.post<any>(this.url + 'admin/login', user);
  }

  loggedIn() {
    return !!localStorage.getItem('token'); // true / false
  }

  getToken() {
    return localStorage.getItem('token');
  }

  logoutUser() {
    this._router.navigate(['/login']);
    return localStorage.removeItem('token');
  }

  getUser(): Observable<any> {
    return this.http.get(this.url + 'getUser').pipe(
      map((res: any) => {
        if (res) {
          return res;
        }
      })
    );
  }
}

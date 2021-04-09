import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from './../../../services/auth.service';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss']
})
export class SigninComponent implements OnInit {
  loginUserData = {
    email: '',
    password: '',
  };
  constructor(private _auth: AuthService, private _router: Router) { }

  ngOnInit(): void {
  }

  onSignIn() {
    this._auth.loginUser(this.loginUserData).subscribe(
      (res) => {
        console.log(res);
        localStorage.setItem('token', res.token);
        this._router.navigate(['/admin/home']);
      },
      (err) => console.log(err)
    );
  }

}

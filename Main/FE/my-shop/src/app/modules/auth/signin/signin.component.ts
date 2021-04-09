import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';
import { FormBuilder, FormGroup } from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.scss']
})
export class SigninComponent implements OnInit {
  constructor(
    private fb: FormBuilder,
    private userService: UserService, //
    private router: Router
  ) {}

  ngOnInit(): void {
    this.createForm();
  }

  loginForm: FormGroup;
  createForm() {
    this.loginForm = this.fb.group({
      username: '',
      password: '',
    });
  }

  success: boolean = false;
  onLogin() {
    let userInfor = {
      email: this.loginForm.value.username,
      password: this.loginForm.value.password,
    };
    this.userService.login(userInfor).subscribe(
      (result) => {
        localStorage.setItem('token', result.token);
        console.log(result.token);
        this.router.navigateByUrl('admin/home');
      },
      (error) => {
        console.log(new Error('Loiiiiiiiiiiiiiiii').toString());
      }
    );
  }

}

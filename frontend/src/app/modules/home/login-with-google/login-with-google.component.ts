import { Component, OnInit } from '@angular/core';
import {GoogleApiService} from "../../../core/services/google-api/google-api.service";

@Component({
  selector: 'app-login-with-google',
  templateUrl: './login-with-google.component.html',
  styleUrls: ['./login-with-google.component.scss']
})
export class LoginWithGoogleComponent implements OnInit {

  constructor(
    private readonly google : GoogleApiService
  ) { }

  ngOnInit(): void {
  }

}

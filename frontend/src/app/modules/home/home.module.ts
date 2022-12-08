import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HomeComponent } from './home/home.component';
import {HomeRoutingModule} from "./home-routing.module";
import {ThemeModule} from "../../core/layout/theme.module";
import {SharedModule} from "../../shared/shared.module";
import { SignupComponent } from './signup/signup.component';
import { LoginComponent } from './login/login.component';
import {ReactiveFormsModule} from "@angular/forms";


@NgModule({
  declarations: [
    HomeComponent,
    SignupComponent,
    LoginComponent,
    SignupComponent
  ],
  imports: [
    CommonModule,
    HomeRoutingModule,
    ThemeModule,
    SharedModule,
    ReactiveFormsModule
  ],
  exports: [
  ],
})
export class HomeModule { }

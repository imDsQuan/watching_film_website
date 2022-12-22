import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { HomeComponent } from './home/home.component';
import {HomeRoutingModule} from "./home-routing.module";
import {ThemeModule} from "../../core/layout/theme.module";
import {SharedModule} from "../../shared/shared.module";
import { SignupComponent } from './signup/signup.component';
import { LoginComponent } from './login/login.component';
import {FormsModule, ReactiveFormsModule} from "@angular/forms";
import { PaymentComponent } from './payment/payment.component';
import { RequestResetComponent } from './password/request-reset/request-reset.component';
import { ResponseResetComponent } from './password/response-reset/response-reset.component';
import { MylistComponent } from './mylist/mylist.component';


@NgModule({
  declarations: [
    HomeComponent,
    SignupComponent,
    LoginComponent,
    SignupComponent,
    PaymentComponent,
    RequestResetComponent,
    ResponseResetComponent,
    MylistComponent
  ],
    imports: [
        CommonModule,
        HomeRoutingModule,
        ThemeModule,
        SharedModule,
        ReactiveFormsModule,
        FormsModule
    ],
  exports: [
  ],
})
export class HomeModule { }

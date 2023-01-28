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
import { PaymentDetailComponent } from './payment/payment-detail/payment-detail.component';
import { ProfileComponent } from './profile/profile.component';
import { ProfileEditComponent } from './profile/profile-edit/profile-edit.component';
import { SearchComponent } from './search/search.component';
import {OAuthModule} from "angular-oauth2-oidc";
import {HttpClientModule} from "@angular/common/http";
import { LoginWithGoogleComponent } from './login-with-google/login-with-google.component';


@NgModule({
  declarations: [
    HomeComponent,
    SignupComponent,
    SignupComponent,
    LoginComponent,
    PaymentComponent,
    RequestResetComponent,
    ResponseResetComponent,
    MylistComponent,
    PaymentDetailComponent,
    ProfileComponent,
    ProfileEditComponent,
    SearchComponent,
    LoginWithGoogleComponent
  ],
    imports: [
        CommonModule,
        HomeRoutingModule,
        ThemeModule,
        SharedModule,
        ReactiveFormsModule,
        FormsModule,
        HttpClientModule,
    ],
  exports: [
  ],
})
export class HomeModule { }

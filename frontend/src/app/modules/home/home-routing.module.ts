import { NgModule } from '@angular/core';
import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./home/home.component";
import {LoginComponent} from "./login/login.component";
import {SignupComponent} from "./signup/signup.component";
import {PaymentComponent} from "./payment/payment.component";
import {AfterLoginService} from "../../core/services/auth/after-login.service";
import {BeforeLoginService} from "../../core/services/auth/before-login.service";
import {RequestResetComponent} from "./password/request-reset/request-reset.component";
import {ResponseResetComponent} from "./password/response-reset/response-reset.component";
import {MylistComponent} from "./mylist/mylist.component";
import {PaymentDetailComponent} from "./payment/payment-detail/payment-detail.component";
import {ProfileComponent} from "./profile/profile.component";
import {SearchComponent} from "./search/search.component";
import {LoginWithGoogleComponent} from "./login-with-google/login-with-google.component";
import {ProfileEditComponent} from "./profile/profile-edit/profile-edit.component";

const routes: Routes = [
  {
    path: '',
    component: HomeComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'login',
    component: LoginComponent,
    canActivate: [BeforeLoginService]
  },
  {
    path: 'signup',
    component: SignupComponent,
    canActivate: [BeforeLoginService]
  },
  {
    path: 'payment',
    component: PaymentComponent,
  },
  {
    path: 'request-password-reset',
    component: RequestResetComponent,
    canActivate: [BeforeLoginService]
  },
  {
    path: 'response-password-reset',
    component: ResponseResetComponent,
    canActivate: [BeforeLoginService]
  },
  {
    path: 'payment/:id',
    component: PaymentDetailComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'payment',
    component: PaymentComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'my-list',
    component: MylistComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'profile/:id',
    component: ProfileEditComponent,
    canActivate: [AfterLoginService]
  },
  // {
  //   path: 'profile',
  //   component: ProfileComponent,
  //   canActivate: [AfterLoginService]
  // },
  // {
  //   path: 'profile',
  //   component: ProfileComponent,
  //   canActivate: [AfterLoginService]
  // },
  {
    path: 'profile',
    component: ProfileComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'search',
    component: SearchComponent,
    canActivate: [AfterLoginService]
  },
  {
    path: 'login-with-google',
    component: LoginWithGoogleComponent,
    canActivate: [BeforeLoginService]
  }

];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule]
})
export class HomeRoutingModule { }

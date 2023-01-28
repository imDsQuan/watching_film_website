import {NgModule} from '@angular/core';
import {BrowserModule} from '@angular/platform-browser';

import {AppRoutingModule} from './app-routing.module';
import {AppComponent} from './app.component';
import {NgxPaginationModule} from 'ngx-pagination'; // <-- import the module
import {HttpClientModule} from '@angular/common/http';
import {HomeModule} from "./modules/home/home.module";
import {NgbModule} from '@ng-bootstrap/ng-bootstrap';
import {BrowserAnimationsModule} from '@angular/platform-browser/animations';
import {ToastrModule} from "ngx-toastr";
import {OAuthModule} from "angular-oauth2-oidc";
import {LoginComponent} from "./modules/home/login/login.component";

@NgModule({
  declarations: [
    AppComponent,
  ],
  imports: [
    BrowserModule,
    HttpClientModule,
    AppRoutingModule,
    NgxPaginationModule,
    HomeModule,
    NgbModule,
    BrowserAnimationsModule,
    ToastrModule.forRoot(),
    OAuthModule.forRoot()
  ],
  providers: [],
  exports: [],
  bootstrap: [AppComponent]
})
export class AppModule {
}

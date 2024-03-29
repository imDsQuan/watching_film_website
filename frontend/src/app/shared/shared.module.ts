import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActorCarouselComponent } from './components/actor-carousel/actor-carousel.component';
import { CastCarouselComponent } from './components/cast-carousel/cast-carousel.component';
import {MovieCarouselComponent} from "./components/movie-carousel/movie-carousel.component";
import { MovieItemComponent } from './components/movie-carousel/movie-item/movie-item.component';
import { CastItemComponent } from './components/cast-carousel/cast-item/cast-item.component';
import { ActorItemComponent } from './components/actor-carousel/actor-item/actor-item.component';
import {MovieRoutingModule} from "../modules/movie/movie-routing.module";
import {BrowserAnimationsModule} from "@angular/platform-browser/animations";
import {MatDialogModule} from '@angular/material/dialog';
import { TrailerPopUpComponent } from './components/trailer-pop-up/trailer-pop-up.component';
import {SafePipe} from "./services/SafePipe";
import { PaymentWarningPopupComponent } from './components/payment-warning-popup/payment-warning-popup.component';

@NgModule({
  declarations: [
    MovieCarouselComponent,
    ActorCarouselComponent,
    CastCarouselComponent,
    MovieItemComponent,
    CastItemComponent,
    ActorItemComponent,
    TrailerPopUpComponent,
    SafePipe,
    PaymentWarningPopupComponent
  ],
  imports: [
    CommonModule,
    MovieRoutingModule,
    MatDialogModule,
  ],
    exports: [
        MovieCarouselComponent,
        ActorCarouselComponent,
        MovieItemComponent,
        SafePipe,
        ActorItemComponent
    ]

})
export class SharedModule { }

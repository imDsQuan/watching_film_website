import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActorCarouselComponent } from './components/actor-carousel/actor-carousel.component';
import { CastCarouselComponent } from './components/cast-carousel/cast-carousel.component';
import {MovieCarouselComponent} from "./components/movie-carousel/movie-carousel.component";
import { MovieItemComponent } from './components/movie-carousel/movie-item/movie-item.component';
import { CastItemComponent } from './components/cast-carousel/cast-item/cast-item.component';
import { ActorItemComponent } from './components/actor-carousel/actor-item/actor-item.component';
import {MovieRoutingModule} from "../modules/movie/movie-routing.module";



@NgModule({
  declarations: [
    MovieCarouselComponent,
    ActorCarouselComponent,
    CastCarouselComponent,
    MovieItemComponent,
    CastItemComponent,
    ActorItemComponent
  ],
  imports: [
    CommonModule,
    MovieRoutingModule,
  ],
  exports: [
    MovieCarouselComponent,
    ActorCarouselComponent,
    MovieItemComponent
  ]

})
export class SharedModule { }

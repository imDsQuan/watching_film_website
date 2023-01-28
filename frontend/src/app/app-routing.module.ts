import {NgModule} from '@angular/core';
import {RouterModule, Routes, PreloadAllModules} from '@angular/router';
import {AfterLoginService} from "./core/services/auth/after-login.service";

const routes: Routes = [
  {
    path: 'actor', loadChildren: () => import('./modules/actor/actor.module').then(m => m.ActorModule),
    canActivate: [AfterLoginService],
  },
  {
    path: '', loadChildren: () => import('./modules/home/home.module').then(m => m.HomeModule),
  },
  {
    path: 'movie', loadChildren: () => import('./modules/movie/movie.module').then(m => m.MovieModule),
    canActivate: [AfterLoginService],
  },
  {
    path: 'tvshow', loadChildren: () => import('./modules/tv-show/tv-show.module').then(m => m.TvShowModule),
    canActivate: [AfterLoginService],
  },
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {preloadingStrategy: PreloadAllModules})],
  exports: [RouterModule]
})
export class AppRoutingModule {
}

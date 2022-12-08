import { NgModule } from '@angular/core';
import { RouterModule, Routes, PreloadAllModules } from '@angular/router';

const routes: Routes = [
  { path: '', loadChildren: () => import('./modules/home/home.module').then(m => m.HomeModule)},
  { path: 'actor', loadChildren : () => import('./modules/actor/actor.module').then(m => m.ActorModule)},
  { path: 'movie', loadChildren : () => import('./modules/movie/movie.module').then(m => m.MovieModule)},
  { path: 'tvshow', loadChildren : () => import('./modules/tv-show/tv-show.module').then(m => m.TvShowModule)},
];

@NgModule({
  imports: [RouterModule.forRoot(routes, {preloadingStrategy : PreloadAllModules})],
  exports: [RouterModule]
})
export class AppRoutingModule { }

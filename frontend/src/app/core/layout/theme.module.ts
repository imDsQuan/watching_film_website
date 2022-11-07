import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LayoutSiteComponent } from "./layout-site/layout-site.component";
import {HomeRoutingModule} from "../../modules/home/home-routing.module";


@NgModule({
  declarations: [
    LayoutSiteComponent
  ],
  imports: [
    CommonModule,
    HomeRoutingModule,
  ],
  exports: [
    LayoutSiteComponent
  ]
})
export class ThemeModule { }

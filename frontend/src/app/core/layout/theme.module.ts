import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { LayoutSiteComponent } from "./layout-site/layout-site.component";
import {HomeRoutingModule} from "../../modules/home/home-routing.module";
import {FormsModule} from "@angular/forms";
import {MatProgressSpinnerModule} from "@angular/material/progress-spinner";


@NgModule({
  declarations: [
    LayoutSiteComponent
  ],
    imports: [
        CommonModule,
        HomeRoutingModule,
        FormsModule,
        MatProgressSpinnerModule,
    ],
  exports: [
    LayoutSiteComponent
  ]
})
export class ThemeModule { }

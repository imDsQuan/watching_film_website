import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-layout-site',
  templateUrl: './layout-site.component.html',
  styleUrls: ['./layout-site.component.scss']
})
export class LayoutSiteComponent implements OnInit {
  active: boolean = false;

  constructor() { }

  ngOnInit(): void {
  }

  showNav() {
    this.active = !this.active
  }
}

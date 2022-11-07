import { ComponentFixture, TestBed } from '@angular/core/testing';

import { LayoutSiteComponent } from './layout-site.component';

describe('LayoutSiteComponent', () => {
  let component: LayoutSiteComponent;
  let fixture: ComponentFixture<LayoutSiteComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ LayoutSiteComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(LayoutSiteComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

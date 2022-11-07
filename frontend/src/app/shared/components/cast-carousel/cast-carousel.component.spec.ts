import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CastCarouselComponent } from './cast-carousel.component';

describe('CastCarouselComponent', () => {
  let component: CastCarouselComponent;
  let fixture: ComponentFixture<CastCarouselComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CastCarouselComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CastCarouselComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

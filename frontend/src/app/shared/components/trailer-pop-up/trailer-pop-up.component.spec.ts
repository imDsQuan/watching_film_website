import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TrailerPopUpComponent } from './trailer-pop-up.component';

describe('TrailerPopUpComponent', () => {
  let component: TrailerPopUpComponent;
  let fixture: ComponentFixture<TrailerPopUpComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TrailerPopUpComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TrailerPopUpComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

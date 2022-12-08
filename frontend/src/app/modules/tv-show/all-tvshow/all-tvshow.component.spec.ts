import { ComponentFixture, TestBed } from '@angular/core/testing';

import { AllTvshowComponent } from './all-tvshow.component';

describe('AllTvshowComponent', () => {
  let component: AllTvshowComponent;
  let fixture: ComponentFixture<AllTvshowComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ AllTvshowComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(AllTvshowComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

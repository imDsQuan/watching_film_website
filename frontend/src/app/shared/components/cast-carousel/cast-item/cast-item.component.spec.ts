import { ComponentFixture, TestBed } from '@angular/core/testing';

import { CastItemComponent } from './cast-item.component';

describe('CastItemComponent', () => {
  let component: CastItemComponent;
  let fixture: ComponentFixture<CastItemComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ CastItemComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(CastItemComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

import { ComponentFixture, TestBed } from '@angular/core/testing';

import { PlanRecipeComponent } from './plan-recipe.component';

describe('PlanRecipeComponent', () => {
  let component: PlanRecipeComponent;
  let fixture: ComponentFixture<PlanRecipeComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ PlanRecipeComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(PlanRecipeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});

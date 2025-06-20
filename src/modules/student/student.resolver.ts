import { Args, Mutation, Query, Resolver, Int } from '@nestjs/graphql';
import { Student } from './student.entity';
import { StudentService } from './student.service';
import { UpdateStudentInput } from './dto/update-student.input';
import { CreateStudentInput } from './dto/create-student.input';


@Resolver(() => Student)
export class StudentResolver {
    constructor(private readonly studentService: StudentService) {}

    @Mutation(() => Student)
    enrollStudent(@Args('input') input: CreateStudentInput) {
        return this.studentService.create(input);
    }

    @Mutation(() => Boolean)
    removeStudent(@Args('id', { type: () => Int }) id: number) {
        return this.studentService.remove(id);
    }

    @Mutation(() => Student, { nullable: true }) 
    updateStudent(@Args('input') input: UpdateStudentInput): Student | null {
    return this.studentService.update(input);
    }


    @Query(() => [Student])
    studentsByClass(@Args('className') className: string) {
    const students = this.studentService.findByClass(className);
    console.log('Filtered students:', students);
    return students;
    }
}
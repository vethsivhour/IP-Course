import { Injectable } from '@nestjs/common';
import { Student } from './student.entity';
import { CreateStudentInput } from './dto/create-student.input';
import { UpdateStudentInput } from './dto/update-student.input';

@Injectable()
export class StudentService {
    private students: Student[] = [];
    private idCounter = 1;

    create(input: CreateStudentInput): Student {
        const student = { id: this.idCounter++, ...input };
        this.students.push(student);
        return student;
    }

    findAll(): Student[] {
        return this.students;
    }

    findByClass(className: string): Student[] {
    return this.students.filter((s) => s.class === className);
    }

    update(input: UpdateStudentInput): Student | null {
    const index = this.students.findIndex((s) => s.id === input.id);
    if (index >= 0) {
        this.students[index] = { ...this.students[index], ...input };
        return this.students[index];
    }
    return null; 
    }


    remove(id: number): boolean {
        const index = this.students.findIndex((s) => s.id === id);
        if (index >= 0) {
        this.students.splice(index, 1);
        return true;
        }
        return false;
    }
}